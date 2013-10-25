// Quiz
$jq =jQuery.noConflict();
var duration = quiz.quizDuration * 60;
var quiz_type = quiz.quizType;

jQuery( function($) {
	
	$('#timer').hide();
	$('#quiz-panel').hide();
	$('.show-result-btn').hide();
	$('.continue-quiz').hide();
	$('#weekly-result-info').hide();
	$('#fast-result-info').hide();
	$('#fast-quiz-success').hide();
	$('#fast-quiz-fail').hide();
	
	// validate terms of services
	$the_terms = $(".terms-services");
	$(".start-quiz").attr("disabled", "disabled");

    $the_terms.click(function() {
        if ($(this).is(":checked")) {
            $(".start-quiz").removeAttr("disabled");
        } else {
            $(".start-quiz").attr("disabled", "disabled");
        }
    });
    
    $('#form-start-quiz').submit(function(e) {
	
		// quiz slider
		$('#quiz-panel').show();
		$('.show-result-btn').show();
		
		$('.quiz-slider').cycle({ 
		    fx:     'scrollLeft', 
		    speed:  'fast', 
		    timeout: 0, 
		    pager:  '.quiz-nav' 
		});
		
		$(this).hide();
		$('#timer').show();
		
		setTimeout("startTimerCount()",1000);
		
		e.preventDefault();
	});
	
	$('.show-result-btn').click(function(){
		$('#timer').hide();
		clearTimeout(quiz_timer);
		wp_quiz_results();
	})

} );

function pretty_time_string(num) {
    return ( num < 10 ? "0" : "" ) + num;
 }

function startTimerCount() {
		
	duration--;
	$minute = Math.floor(duration/60);
	$second = Math.floor(duration%60);
	
	$minute = pretty_time_string($minute);
	$second = pretty_time_string($second);

	$jq('#timer').html($minute+":"+$second+" min");	 
    if ( duration == '0' ) {
        $jq('#timer').html("Time Up");
        wp_quiz_results();
        return;
    }
    quiz_timer = setTimeout("startTimerCount()",1000);
}


var wp_quiz_results = function (){
	
	var selected_answers = {};
    $jq(".ques-answers").each(function(){
        var question_id = $jq(this).attr("data-quiz-id");

        var selected_answer = $jq(this).find('input[type=radio]:checked');
        if(selected_answer.length != 0){
            var selected_answer = $jq(selected_answer).val();
         
            selected_answers["qid_"+question_id] = selected_answer;
            
        }else{
            selected_answers["qid_"+question_id] = '';
        }

    });
	
	$jq.post(quiz.ajaxURL, {
        action:"get_quiz_results",
        nonce:quiz.quizNonce,
        data : selected_answers,
        quiztype: quiz_type
    }, function(data) {
    	
    	if (quiz_type == 'fast' && data.score == '5'){
    		var fast_quiz_win = parseInt($jq('.fast-quiz-win').text())+1;
    		$jq('.fast-quiz-win').html(fast_quiz_win);
    		$jq('#fast-quiz-success').show();
    	} else if(quiz_type == 'fast' && data.score < '5') {
	    	$jq('#fast-quiz-fail').show();
    	}

        if (quiz_type == 'fast'){
			$jq('.fast-score').html( parseInt($jq('.fast-score').text())+data.score );
			$jq('.fast-quiz-win').html( parseInt($jq('.fast-quiz-win').text())+data.score );
			$jq('#fast-result-info').show();
		}
        
        if (quiz_type == 'weekly'){
			$jq('.weekly-score').html( parseInt($jq('.weekly-score').text())+data.score );
			$jq('.weekly-score-profile').html( parseInt($jq('.weekly-score-profile').text())+data.score );
			$jq('#weekly-result-info').show();
		}	
		
		$jq('.continue-quiz').show();
		
        $jq('.entry-header').hide();
        $jq('.entry-body').hide();
        $jq('.show-result-btn').hide();
        $jq('#timer').hide();
        $jq("#quiz-panel").hide();
        
    	var total_questions = data.total_questions;

        //print result info
        var result_html = "<table class='number'>";
        result_html += "<tr><th>Question</th><th>Answer</th><th>Correct Answer</th><th>Result</th></tr>";
        var quiz_index = 1;
        $jq.each(data.result, function( key, ques ) {
        	result_html += "<tr><td>"+quiz_index+"</td><td>"+ques.answer+"</td><td>"+ques.correct_answer+"</td>";
            result_html += "<td><img src='"+quiz.theme_url+"assets/images/"+ques.mark+".gif' /></td></tr>";

            quiz_index++;
        });

        result_html += "</table>";
        //$jq("#quiz-result").html(result_html);

    }, "json");  
};