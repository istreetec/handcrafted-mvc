<!-- $this can be used to reach for properties on the View class -->
<h1>
    <?= $this->params["foo"] ?>
</h1>

<form action="/upload" method="post" enctype="multipart/form-data">
    <input type="file" name="receipt" id="receipt" />
    <button type="submit">Upload</button>
</form>
