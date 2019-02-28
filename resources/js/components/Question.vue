<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <form
          v-show="authorize('modify', question) && editing"
          class="card-body"
          @submit.prevent="update"
        >
          <div class="card-title">
            <input
              v-model="title"
              type="text"
              class="form-control form-control-lg"
            >
          </div>
          <hr>
          <div class="media">
            <div class="media-body">
              <div class="form-group">
                <m-editor :body="body">
                  <textarea
                    v-model="body"
                    class="form-control"
                    rows="10"
                    required
                  />
                </m-editor>
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
            </div>
          </div>
        </form>
        <div
          v-show="!editing"
          class="card-body"
        >
          <div class="card-title">
            <div class="d-flex align-items-center">
              <h1>{{ title }}</h1>
              <div class="ml-auto">
                <a
                  href="/questions"
                  class="btn btn-outline-secondary"
                >Back to all questions</a>
              </div>
            </div>
            <hr>
            <div class="media">
              <vote
                :model="question"
                name="question"
              />
              <div class="media-body">
                <div
                  ref="bodyHtml"
                  v-html="bodyHtml"
                />
                <div class="row">
                  <div class="col-4">
                    <div class="ml-auto">
                      <a
                        v-if="authorize('modify', question)"
                        class="btn btn-sm btn-outline-info"
                        @click.prevent="edit"
                      >Edit</a>
                      <button
                        v-if="authorize('deleteQuestion', question)"
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
                      :model="question"
                      label="Asked"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Prism from 'prismjs';
import Vote from './Vote.vue';
import UserInfo from './UserInfo.vue';
import MEditor from './MEditor.vue';

export default {
  components: {
    Vote,
    UserInfo,
    MEditor,
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
      title: this.question.title,
      body: this.question.body,
      bodyHtml: this.question.body_html,
      editing: false,
      id: this.question.id,
      beforeEditCache: {},
    };
  },
  computed: {
    isInvalid() {
      return this.body.length < 10 || this.title.length < 10;
    },
    endpoint() {
      return `/questions/${this.id}`;
    },
  },
  methods: {
    edit() {
      this.beforeEditCache = {
        body: this.body,
        title: this.title,
      };
      this.editing = true;
    },
    cancel() {
      this.body = this.beforeEditCache.body;
      this.title = this.beforeEditCache.title;
      this.editing = false;
      const el = this.$refs.bodyHtml;
      if (el) {
        Prism.highlightAllUnder(el);
      }
    },
    update() {
      axios.put(this.endpoint, {
        body: this.body,
        title: this.title,
      })
        .then(({ data }) => {
          this.bodyHtml = data.body_html;
          this.$toast.success(data.message, 'Success', {
            timeout: 3000,
            position: 'bottomLeft',
          });
          this.editing = false;
        })
        .catch(({ response }) => {
          this.$toast.error(response.data.message, 'Error', {
            timeout: 3000,
            position: 'bottomLeft',
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
                .then(({ data }) => {
                  this.$toast.success(data.message, 'Success', {
                    timeout: 2000,
                  });
                });
              setTimeout(() => {
                window.location.href = '/questions';
              }, 3000);
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

<style lang="css" scoped>
</style>
