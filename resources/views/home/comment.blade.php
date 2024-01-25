<section class="product_section layout_padding">
         <div class="container">
            <div class="heading_container heading_center">
               <h2>
                   <span>Comments</span>
               </h2>
               <form action="{{url('add_comment')}}" method="POST">
                @csrf
                    <textarea placeholder="Comment Something Here" name="comment" cols="100" rows="10"></textarea>
                    <input type="submit" class="btn btn-primary" value="Comment">
               </form>
            </div>
            <div style="padding-left:20px;">
                <h1 style="font-size:20px;padding-bottom:20px;">All Comments</h1>
                @foreach($comment as $comment)
                <div>
                    <b>{{$comment->name}}</b>
                    <p>{{$comment->comment}}</p>
                    <a style="color: blue;" href="javascript::void(0)" onclick="reply(this)" data-Commentid="{{$comment->id}}">Reply</a>
                    @foreach($reply as $rep)
                    @if($rep->comment_id==$comment->id)
                    <div style="padding-left:3%;padding-top:10px;padding-bottom:10px;">
                        <b>{{$rep->name}}</b>
                        <p>{{$rep->reply}}</p>
                        <a style="color: blue;" href="javascript::void(0)" onclick="reply(this)" data-Commentid="{{$comment->id}}">Reply</a>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endforeach
                <!-- Reply div -->
                <div style="display: none;" class="replyDiv">
                    <form action="{{url('add_reply')}}" method="POST">
                    @csrf
                        <input type="text" name="commentId" id="commentId" hidden="">
                        <textarea placeholder="Write Something Here" name="reply" style="height:100px;width:400px;"></textarea>
                        <br>
                        <button type="submit" class="btn btn-warning">Reply</button>
                        <a href="javascript::void(0)" onclick="reply_close(this)" class="btn">Close</a>
                    </form>
                </div>
            </div>
         </div>
      </section>