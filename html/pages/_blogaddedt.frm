<div class="container pressTable">
<p>@STATUS@</p>
<form method="post" action="?page=_blogaddedt&pressid=@PRESSID@" enctype="multipart/form-data">
	<p>
	Show on main page:<input type="checkbox" name="mainpage" @MAINPG@>
	</p>
	<p>
	Test Mode:<input type="checkbox" name="testmode" @TESTMODE@>
	</p>
	<p>
	@PREVIEWLINK@
	</p>
	<p>
	<label>Alt for img</label>
	<input type="text" name="imgalt" value="@IMGALT@">
	<input type="file" name="image">
	@IMAGE@
	</p>
	<p>
	<label>Author</label>
	<input type="text" name="author" value="@AUTHOR@">
	</p>
	<p>
	<label>Title</label>
	<input type="text" name="title" value="@TITLE@">
	</p>
	<p>
	<label>Subtitle</label>
	<textarea name="subtitle" style="width:100%;" class="editor">@SUBTITLE@</textarea>
	</p>
	<p>
	<label>Date</label>
	<input type="text" name="date" value="@DATE@">
	</p>
	<p>
	<label>Lead</label>
	<textarea name="lead" style="width:100%;" class="editor">@LEAD@</textarea>
	</p>
	<p>
	<label>Body</label>
    <textarea name="body" style="width:100%;" class="editor">@BODY@</textarea>
    </p>
    <p>
	<label>Meta Tags</label>
    <textarea name="meta" style="width:100%;">@META@</textarea>
    </p>
    <input type="submit" class="btn btn-lg btn-primary"name="@BUTTON@" value="@BUTTON@">
	<input type="hidden" name="action" value="@ACTION@"> 
</form>
</div>
