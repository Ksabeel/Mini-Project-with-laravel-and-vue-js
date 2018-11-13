<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <a class="navbar-brand" href="/">Laravel & Vue JS</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <router-link to="/" tag="li" active-class="active" exact>
            <a class="nav-link">Home</a>
          </router-link>

          <router-link to="/about" tag="li" active-class="active">
            <a class="nav-link">About</a>
          </router-link>

          <router-link to="/contact" tag="li" active-class="active">
            <a class="nav-link">Contact</a>
          </router-link>
        </ul>
      </div>
    </nav>
</template>

<script>
    export default {
    };
</script>
