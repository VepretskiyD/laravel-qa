<template>
  <div
    v-cloak
    v-if="count"
    class="row mt-4"
  >
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h2>{{ title }}</h2>
            <hr>
            <answer
              v-for="answer in answers"
              :key="answer.id"
              :answer="answer"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Answer from './Answer.vue';

export default {
  components: {
    Answer,
  },
  props: {
    answers: {
      type: Array,
      default() {
        return [];
      },
    },
    count: {
      type: Number,
      default: 0,
    },
  },
  computed: {
    title() {
      return this.count + ' ' + (this.count > 1 ? 'Answers' : 'Answer');
    },
  },
};
</script>

<style lang="css" scoped>
</style>
