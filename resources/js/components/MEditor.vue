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
        v-html="preview"
      >
        Preview...
      </div>
    </div>
  </div>
</template>

<script>
import MarkdownIt from 'markdown-it';
import autosize from 'autosize';
import prism from 'markdown-it-prism';

const md = new MarkdownIt();
md.use(prism);

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
  watch: {
    body() {
      autosize(this.$el.querySelector('textarea'));
    },
  },
  mounted() {
    autosize(this.$el.querySelector('textarea'));
  },
};
</script>

<style lang="css" scoped>
</style>
