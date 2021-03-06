<template>
  <div class="media post">
    <vote
      :model="answer"
      name="answer"
    />
    <div class="media-body">
      <form
        v-if="editing"
        @submit.prevent="update"
      >
        <div class="form-group">
          <textarea
            v-model="body"
            class="form-control"
            rows="10"
            required
          />
        </div>
        <button
          class="btn btn-primary"
          type="submit"
          :disabled="isInvalid"
        >
          Update
        </button>
        <button
          class="btn btn-outline-secondary"
          type="button"
          @click="cancel"
        >
          Cancel
        </button>
      </form>
      <div v-else>
        <div v-html="bodyHtml" />
        <div class="row">
          <div class="col-4">
            <div class="ml-auto">
              <a
                v-if="authorize('modify', answer)"
                class="btn btn-sm btn-outline-info"
                @click.prevent="edit"
              >Edit</a>
              <button
                v-if="authorize('modify', answer)"
                type="button"
                class="btn btn-sm btn-outline-danger"
                @click="destroy"
              >
                Delete
              </button>
            </div>
          </div>
          <div class="col-4" />
          <div class="col-4">
            <user-info
              :model="answer"
              label="Answered"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vote from './Vote.vue';
import UserInfo from './UserInfo.vue';

export default {
  components: {
    Vote,
    UserInfo,
  },
  props: {
    answer: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {
      editing: false,
      body: this.answer.body,
      bodyHtml: this.answer.body_html,
      id: this.answer.id,
      questionId: this.answer.question_id,
      beforeEditCache: null,
    };
  },
  computed: {
    isInvalid() {
      return this.body.length < 10;
    },
    endpoint() {
      return `/questions/${this.questionId}/answers/${this.id}`;
    },
  },
  methods: {
    edit() {
      this.beforeEditCache = this.body;
      this.editing = true;
    },
    cancel() {
      this.body = this.beforeEditCache;
      this.editing = false;
    },
    update() {
      axios.patch(this.endpoint,
        {
          body: this.body,
        })
        .then((res) => {
          this.bodyHtml = res.data.body_html;
          this.editing = false;
          this.$toast.success(res.data.message, 'Success',
            {
              timeout: 3000,
            });
        })
        .catch((err) => {
          this.$toast.error(err.response.data.message, 'Error',
            {
              timeout: 3000,
            });
        });
    },
    destroy() {
      this.$toast.question('Are you sure about that?', 'Hey',
        {
          timeout: 20000,
          close: false,
          overlay: true,
          displayMode: 'once',
          id: 'question',
          zindex: 999,
          position: 'center',
          buttons: [
            ['<button><b>YES</b></button>', (instance, toast) => {
              axios.delete(this.endpoint)
                .then((res) => {
                  this.$emit('deleted');
                });
              instance.hide(
                {
                  transitionOut: 'fadeOut',
                }, toast, 'button',
              );
            }, true],
            ['<button>NO</button>', function (instance, toast) {
              instance.hide(
                {
                  transitionOut: 'fadeOut',
                }, toast, 'button',
              );
            }],
          ],
        });
    },
  },
};
</script>
