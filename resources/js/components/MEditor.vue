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
          />
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
        v-html="preview"
      >
        Preview...
      </div>
    </div>
  </div>
</template>

<script>
import MarkdownIt from 'markdown-it';

const md = new MarkdownIt();

export default {
  props: {
    body: {
      type: String,
      default: '',
    },
  },
  computed: {
    preview() {
      return md.render(this.body);
    },
  },
};
</script>

<style lang="css" scoped>
</style>
