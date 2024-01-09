<script>
    $(function() { 
        $('body').on('click', '#commentsList tr.comment', function() {
            $('#commentId').val($(this).data('comid'));
            $('#commentsList tr.comment').removeClass('success');
            $(this).addClass('success');
            $('#task_form input[name="name"]').val($(this).find('.text p').html().replace(/<\/?[^>]+>/gi, ''));
        });

        $('body').on('click', '#getCommentsBtn', function () {
           getComments();
        });

        $('body').on('change', '#task_form input[name="url"]', function(){
			var CurrentUrl = document.querySelector('#task_form input[name="url"]').value;
			if(CurrentUrl.includes('youtube') || CurrentUrl.includes('youtu')){
                clearComments();
                getComments();
				 console.log("Form state change");
			}
        });

       // $('body').on('keyup', '#task_form input[name="url"]', function(){
       //     clearTimeout(timer);
       //     timer = setTimeout(function(){
        //            clearComments();
       //             getComments();
		//		 console.log("keyup state change");
       //     },1000)
       // });

    });


    var vid = '', apiKey = 'AIzaSyAgkXJD24gt8v1mjtOAojd3cWS5NojvNvc',
        ytApi = "https://www.googleapis.com/youtube/v3/commentThreads?",
        reachLastPage = false;

    var nextPageToken;

    function clearComments() {
        $('#commentsList tr.comment').remove();
    }

    function getComments() {

        vid = getTaskVid();

        if(!vid || reachLastPage) {
            return false;
        }

        $.getJSON( ytApi, {
            part: "snippet",
            key: apiKey,
            maxResults: "10",
            videoId: getTaskVid(),
            pageToken: nextPageToken,
            order: "relevance"
        })
        .done(function( data ) {
		console.log("Api request done");
            $.each( data.items, function( i, item ) {
                var imgurl = item.snippet.topLevelComment.snippet.authorProfileImageUrl;
                var re = /s28/gi;
                var newurl = imgurl.replace(re, 's48');
                var ctext = item.snippet.topLevelComment.snippet.textDisplay;
                var comid = item.snippet.topLevelComment.id;
				//var elements = document.getElementsByClassName("comment");
                $( "#commentsList > tbody > tr:last" ).before(
                    '<tr class="comment" data-comid="'+comid+'">'+'<td>'+'<img src="'+newurl+'"/>'+'</td>'+'<td class="text"><p>'+ctext+'</p></td></tr>'
                );
            });
			if (data.hasOwnProperty('nextPageToken')){
                nextPageToken = data.nextPageToken;
                console.log("go to token : " + data.nextPageToken);
                //nextButton(data.nextPageToken);
            } else {
                console.log("no page left");
                reachLastPage = true;
            }

        });

    };
</script>


<div class="form-group">

    <label for="commentId">Выбор комментария, на который нужен ответ</label>
    <?php $comment_id = isset($task->extend['comment_id']) ? $task->extend['comment_id'] : ''; ?>
    <input type="hidden" class="form-control" id="commentId" name="extend[comment_id]" value="<?=set_value('extend[comment_id]', $comment_id);?>" size="50" placeholder="" />
<br />
    <div class="table-responsive">
        <table id="commentsList" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Аватарка</th>
                <th>Комментарий</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        <a class="btn btn-primary" id="getCommentsBtn">Загрузить комментарии</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>