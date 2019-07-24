<!-- Static navbar -->
<div class="navbar navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?= site_url(); ?>">codebook</a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?= site_url('information/values');?>">Our Values</a></li>
        <li><a href="<?= site_url('information/contact');?>">Talk to Us</a></li>
        <li><a href="<?= site_url('login'); ?>">Login</a></li>
        <li><a href="<?= site_url('user/registration'); ?>">Sign Up</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47023421-2', 'codebooklearning.com');
  ga('send', 'pageview');

</script>
</div>