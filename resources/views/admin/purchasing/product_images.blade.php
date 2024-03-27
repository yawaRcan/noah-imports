<style>
 .selectable-image {
  cursor: pointer;
}

.image-wrapper {
  position: relative;
  display: inline-block;  
}  
.selected-img{
    border: 2px solid green;
}
.image-wrapper.selected-img::after {
  content: '\2714'; /* Tick mark symbol */
  color: green;
  font-weight: bold;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  
}
</style>

<div class="card shadow text-start">
    <div class="card-body">
        <div class="row">
         
            @foreach($imageUrls as $key => $url)
            <div class="col-6 col-sm-6 col-md-4 mt-2">
                <div class="image-container">
                    <div class="image-wrapper">
                        <img src="{{$url}}" class="shadow card-hover selectable-image" width="100px" data-radio="radio-{{$url}}"> 
                        <input type="radio" name="image_url" class="external-input-image hide" value="{{$url}}" id="radio-{{$url}}">
                    </div> 
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
var selectableImages = document.querySelectorAll('.selectable-image');



$('#product_name').val("{{$title}}");
$('#product_website').val("{{$website}}");
$('#price').val("{{$price}}"); 
$('#product_name-item').val("{{$title}}");
$('#product_website-item').val("{{$website}}");
$('#price-item').val("{{$price}}"); 
$('.item-number').val("{{$itemNumber}}"); 
$('#quantity').val("{{$quantity}}"); 
$('#currencyId').text("{{$currency}}");
$('#size').attr("placeholder","{{$size}}"); 




selectableImages.forEach((image) => {
  image.addEventListener('click', () => { 
    selectableImages.forEach((img) => {
      img.parentElement.classList.remove('selected-img'); 
    }); 
    // Add 'selected' class to the clicked image's parent container
    image.parentElement.classList.add('selected-img');
    // Get the radio button ID associated with the clicked image
    var radioId = image.getAttribute('data-radio'); 
    // Select the associated radio button
    var radioBtn = document.getElementById(radioId);
    radioBtn.checked = true;
  });
});
</script>