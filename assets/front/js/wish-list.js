function initAddToWishlist () { 
  $(".addToWishlist").on("click", function(e) {
      e.preventDefault();
      var form = $(this).next('form');
      var productwrap = $(this).parents('.product-preview');
      $.ajax({
          type: 'POST',
          url: '/contact',
          data: form.serialize(),
          beforeSend: function() {
             showLoading();
          },
          success: function(data) {
              hideLoading();
              productwrap.find('.wishlist').removeClass('addToWishlist');
              productwrap.find('.wishlist').attr('title', 'This product is in your wishlist');
              var title = $(productwrap).find('.product-title').html();
              var image = $(productwrap).find('.preview img').attr('src');
              $('.ajax-success-modal').find('.ajax-product-title').html(title);
              $('.ajax-success-modal').find('.ajax-product-image').attr('src', image);
              $('.ajax-success-modal').find('.btn-go-to-wishlist').show();
              $('.ajax-success-modal').find('.btn-go-to-cart').hide();
              showModal('.ajax-success-modal');
          },
          error: function(xhr, text) {
              hideLoading();
              $('.loading-modal').hide();
              $('.ajax-error-message').text($.parseJSON(xhr.responseText).description);
              showModal('.ajax-error-modal');
          }
      });
  });
}
initAddToWishlist();  

// ======================================================
// remove from wishlist
// ======================================================
$(".wishlist-remove").on("click", function(e) {  
  var row = $(this).parents('tr');
  var tagID = row.find('.tag-id').val();
  var form = jQuery('#remove-wishlist-form');
  form.find("input[name='contact[tags]']").val('x' + tagID);
  $.ajax({
       type: 'POST',
       url: '/contact',
       data: form.serialize(),
       beforeSend: function() {
           showLoading();
       },
       success: function(data) {
           hideLoading();
           row.fadeOut(1000);
       },
       error: function(xhr, text) {
           hideLoading();
           $('.loading-modal').hide();
           $('.ajax-error-message').text($.parseJSON(xhr.responseText).description);
           showModal('.ajax-error-modal');
        }
   });
});

// ======================================================
// add to cart from wishlist
// ======================================================
$(".js-add-to-cart").on("click", function(e) {
  e.preventDefault();
  variantID = $(this).attr("data-id");
  $('#product-select').attr("value", variantID);
  // uncomment next line if you want a product to be removed from the wish list when it is added to the cart
  //removeFromWishlist($(this));
  $('#add-variant').submit();
});
