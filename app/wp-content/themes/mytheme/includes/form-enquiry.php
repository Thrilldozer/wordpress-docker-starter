<div id="success_message" class="alert alert-success" style="display:none"></div>

<form id="enquiry">

  <h2>Send your enquiry about this <?php the_title();?></h2>

  <input type="hidden" name="registration" value="<?php the_field('registration');?>">

  <div class="form-group row">

    <div class="col-lg-6">
      <label for="">First Name</label>
      <input type="text" name="fname" placeholder="First Name" required class="form-control">
    </div>

    <div class="col-lg-6">
    <label for="">Last Name</label>
      <input type="text" name="lname" placeholder="Last Name" required class="form-control">
    </div>

  </div>

  <div class="form-group row">

  <div class="col-lg-6">
  <label for="">Email address</label>
      <input type="text" name="email" placeholder="Email" required class="form-control">
    </div>

    <div class="col-lg-6">
    <label for="">Phone number</label>
      <input type="tel" name="phone" placeholder="Phone Number" required class="form-control">
    </div>

  </div>

  <div class="form-group">
    <textarea name="enquiry" class="form-control" required placeholder="Your Enquiry"></textarea>
  </div>

  <div class="form-group">
    <button class="btn btn-success btn-block" type="submit">Send your enquiry</button>
  </div>

</form>

<script>

(function($){

  $('#enquiry').submit( function(event){

    event.preventDefault()

    const endpoint = '<?php echo admin_url('admin-ajax.php');?>';

    const form = $('#enquiry').serialize();

    let formdata = new FormData;

   formdata.append('action', 'enquiry');
   formdata.append('enquiry', form);

   $.ajax(endpoint, {

    type: 'POST',
    data: formdata,
    processData: false,
    contentType: false,

    success: function(res) {
      $('#enquiry').fadeOut(200);
      $('#success_message').text('Thanks for your enquiry').show();
      $('#enquiry').trigger('reset');
      $('#enquiry').fadeIn(500);
    },
    error: function(err) {
      $('#enquiry').fadeOut(200);
      $('#success_message').text('Thanks for your enquiry').show();
      $('#enquiry').fadeIn(500);
    }

   })

})

})(jQuery)  

</script>