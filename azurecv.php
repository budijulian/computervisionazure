<!-- tombol memulai submit analisis -->
<?php
if (isset($_POST['submit'])) {
  if (isset($_POST['url'])) {
    $url = $_POST['url'];
  } else {
    header("Location: index.php");
  }
} else {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <title>Image Processing</title>
</head>
<body>
    <script type="text/javascript">
        function processImage() {
            // **********************************************
            // *** Update or verify the following values. ***
            // **********************************************
     
            // Replace <Subscription Key> with your valid subscription key.
            var subscriptionKey = "02ede4bca4ff40d0ac998cbdf737d4e7";
     
            // You must use the same Azure region in your REST API method as you used to
            // get your subscription keys. For example, if you got your subscription keys
            // from the West US region, replace "westcentralus" in the URL
            // below with "westus".
            //
            // Free trial subscription keys are generated in the "westus" region.
            // If you use a free trial subscription key, you shouldn't need to change
            // this region.
            var uriBase =
                "https://dicodingcv.cognitiveservices.azure.com/vision/v2.0/analyze";
     
            // Request parameters.
            var params = {
                "visualFeatures": "Categories,Description,Color",
                "details": "",
                "language": "en",
            };
     
            // Display the image.
            var sourceImageUrl = "<?php echo $url ?>";
            document.querySelector("#sourceImage").src = sourceImageUrl;
     
            // Make the REST API call.
            $.ajax({
                url: uriBase + "?" + $.param(params),
     
                // Request headers.
                beforeSend: function(xhrObj){
                    xhrObj.setRequestHeader("Content-Type","application/json");
                    xhrObj.setRequestHeader(
                        "Ocp-Apim-Subscription-Key", subscriptionKey);
                },
     
                type: "POST",
     
                // Request body.
                data: '{"url": ' + '"' + sourceImageUrl + '"}',
            })
     
            .done(function(data) {
                // Show formatted JSON on webpage.
                $("#responseTextArea").val(JSON.stringify(data, null, 2));
                 console.log(data.categories[0].name);
            console.log(data.description.captions[0]);
            console.log(data);
            data1 = data.description.captions[0].text;
            data2 = data.categories[0].name;
            document.getElementById("hasil").innerHTML = data1;



            
            })
     
            .fail(function(jqXHR, textStatus, errorThrown) {
                // Display error message.
                var errorString = (errorThrown === "") ? "Error. " :
                    errorThrown + " (" + jqXHR.status + "): ";
                errorString += (jqXHR.responseText === "") ? "" :
                    jQuery.parseJSON(jqXHR.responseText).message;
                alert(errorString);
            });
        };
    </script>

<div class="container mt-5">
    <div class="card">
      <div class="card-header">ANALISIS GAMBAR</div>
      <div class="card-body">
        <button class="btn btn-success" onclick="processImage()">MULAI</button><br>
        <div class="row">
            <div class="col py-3 px-lg-5 border bg-light">
              <div id="imageDiv" class="col col-sm-12 text-center">
                <p class="text-info">Gambar</p>
                <img class="img-responsive" id="sourceImage" width="200" />
              </div>
            </div>
            <div class="col py-3 px-lg-5 border bg-light">
              <div id="jsonOutput" style="width:400px; display:table-cell;">
                <p class="text-info">Hasil</p>
                <div class="alert alert-primary" role="alert">
                  <figcaption id="hasil"></figcaption>
                </div>
              </div>
            </div>
          </div>
      <a href="index.php" class="btn btn-secondary">KEMBALI</a>
      </div>
    </div>
</div>

</body>
</html>
