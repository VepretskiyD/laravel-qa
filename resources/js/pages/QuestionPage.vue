<template>
  <div class="container">
    <question
      :question="question"
    />
    <answers :question="question" />
  </div>
</template>

<script>
import Question from '../components/Question.vue';
import Answers from '../components/Answers.vue';

export default {
  components: {
    Question,
    Answers,
  },
  props: {
    question: {
      type: Object,
      default() {
        return {};
      },
    },
  },
};
</script>

<style lang="css" scoped>
</style>
