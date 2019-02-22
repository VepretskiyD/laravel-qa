<template>
  <div class="d-flex flex-column vote-controls">
    <a
      :title="title('up')"
      class="vote-up"
      :class="classes"
      @click.prevent="voteUp"
    >
      <i class="fas fa-caret-up fa-3x" />
    </a>
    <span class="votes-count">{{ count }}</span>
    <a
      :title="title('down')"
      class="vote-down"
      :class="classes"
      @click.prevent="voteDown"
    >
      <i class="fas fa-caret-down fa-3x" />
    </a>
    <favorite
      v-if="name === 'question'"
      :question="model"
    />
    <accept
      v-if="name ==='answer'"
      :answer="model"
    />
  </div>
</template>

<script>
import Favorite from './Favorite.vue';
import Accept from './Accept.vue';

export default {
  components: {
    Favorite,
    Accept,
  },
  props: {
    name: {
      type: String,
      default: '',
    },
    model: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {
      count: this.model.votes_count || 0,
      id: this.model.id,
    };
  },
  computed: {
    classes() {
      return [!this.signedIn ? 'off' : ''];
    },
    endpoint() {
      return `/${this.name}s/${this.id}/vote`;
    },
  },
  methods: {
    title(voteType) {
      const titles = {
        up: `This ${this.name} is useful`,
        down: `This ${this.name} is not useful`,
      };
      return titles[voteType];
    },
    voteUp() {
      this._vote(1);
    },
    voteDown() {
      this._vote(-1);
    },
    _vote(vote) {
      if (!this.signedIn) {
        this.$toast.warning(`Please, login to vote the ${this.name}`, 'Warning', {
          timeout: 3000,
          position: 'bottomLeft',
        });
      } else {
        axios.post(this.endpoint, {
          vote,
        })
          .then((res) => {
            this.$toast.success(res.data.message, 'Success', {
              position: 'bottomLeft',
              tiemout: 3000,
            });
            this.count = res.data.votesCount;
          });
      }
    },
  },
};
</script>

<style lang="css" scoped>
</style>
