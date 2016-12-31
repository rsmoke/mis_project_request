$(function () {
  input_counter('short_description');

});

function input_counter(input_box){
  var count = $('#'+ input_box).val().length;
  var max = 140;
  $('#statusArea').text('Use less than ' + max + ' characters.');

  $('#'+ input_box).keyup( function(){
      count = $('#'+ input_box).val().length;
      $('#statusArea').empty();
      $('#statusArea').text((max - count) + ' characters left.');
      if (count >= 150) {
          $('#'+ input_box).prop('disabled', true);
      }
  }).change();

  $('#'+ input_box).keypress(function(e) {
      if (e.which < 0x20) {
          // e.which < 0x20, then it's not a printable character
          // e.which === 0 - Not a character
          return;     // Do nothing
      }
      if (this.value.length == max) {
          e.preventDefault();
      } else if (this.value.length > max) {
          // Maximum exceeded
          this.value = this.value.substring(0, max);
      }
  });
}
