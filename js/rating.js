/*
 * Send new user choice, then recieve object where define what need to change
 * and change selects
 */

function SetRating(value, good) {
        $.ajax({
                url:"/review/setmark",
                type:'GET',
                data: "good_id="+good+"&rate=" + value,
                success: RatingSet
        });
}

function RatingSet(data){
	
}
