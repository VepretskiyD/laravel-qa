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
              v-for="(answer, index) in answers"
              :key="answer.id"
              :answer="answer"
              @deleted="remove(index)"
            />
            <div class="text-center mt-3">
              <button
                v-if="nextUrl"
                type="button"
                class="btn btn-outline-secondary"
                @click.prevent="fetch(nextUrl)"
              >
                Load more answers
              </button>
            </div>
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
    question: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {
      questionId: this.question.id,
      count: this.question.answers_count,
      answers: [],
      nextUrl: null,
    };
  },
  computed: {
    title() {
      return `${this.count} ${this.count > 1 ? 'Answers' : 'Answer'}`;
    },
  },
  created() {
    this.fetch(`/questions/${this.questionId}/answers`);
  },
  methods: {
    fetch(endpoint) {
      axios.get(endpoint)
        .then(({ data }) => {
          this.answers.push(...data.data);
          this.nextUrl = data.next_page_url;
        });
    },
    remove(index) {
      this.answers.splice(index, 1);
      this.count -= 1;
    },
  },
};
</script>

<style lang="css" scoped>
</style>
