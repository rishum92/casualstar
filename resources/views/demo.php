<html lang="en">
<head>
<meta charset="UTF-8">
<title>jQuery Inserting Textarea Value into an iFrame</title>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style type="text/css">
    textarea, iframe{
        display: block;
    margin: 10px 0;
    }
    iframe{
        width: 500px;
        border: 1px solid #a9a9a9;
    }
</style>
<script type="text/javascript">
    function updateIframe(){
      var myFrame = $("#myframe").contents().find('body');
      var textareaValue = $("textarea").val();
      myFrame.html(textareaValue);
    }

</script>
</head>
<body>
  <textarea id="editadmin" rows="5" cols="50" placeholder="Type HTML or text here...">
  this is modify by the admin 
  </textarea>
    <button type="button" onclick="updateIframe()">Insert Content</button>
    <iframe id="myframe"></iframe>
</body>
</html>                            