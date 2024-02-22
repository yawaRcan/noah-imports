<form class="form-horizontal" id="user-email-form" action="javascript:void(0)"> 
    @csrf 
    <label for="tb-remail">From Email</label>
    <div class="input-group mb-3">
        <span class="input-group-text fa fa-envelope"></span>
        <input class="form-control" type="email" name="email" value="{{$user->email}}" />
    </div>
    <label for="tb-remail">Subject</label>
    <div class="input-group mb-3">
        <span class="input-group-text fa fa-envelope"></span>
        <input id="subject" class="form-control" type="text" name="subject" />
    </div>
    <label for="tb-remail">Message</label>
    <div class="form-group-group mb-3">
        <textarea cols="80" id="message" name="message" rows="10">
        </textarea>
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="user-email-button" data-user-id="{{$user->id}}">Send</button>
    </div>
</form>
<script type="text/javascript">

    var editor = CKEDITOR.replace( 'message' );

// The "change" event is fired whenever a change is made in the editor.
editor.on( 'change', function( evt ) {
   $("#message").val(evt.editor.getData());
});
</script>