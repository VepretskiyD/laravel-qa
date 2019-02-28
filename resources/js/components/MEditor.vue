<template lang="html">
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a
            class="nav-link active"
            href="#write"
            data-toggle="tab"
          >Write</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            href="#preview"
            data-toggle="tab"
          >Preview</a>
        </li>
      </ul>
    </div>
    <div class="card-body tab-content">
      <div
        id="write"
        class="tab-pane active"
      >
        <slot />
      </div>
      <div
        id="preview"
        class="tab-pane"
      >
        Preview...
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    body: {
      type: String,
      default: '',
    },
  },
};
</script>

<style lang="css" scoped>
</style>
