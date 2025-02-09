panel.plugin("tfk/block-testimonial", {
  blocks: {
    testimonial: {
      computed: {
        media() {
          if (this.content.media[0]) {
            return this.content.media[0].url;
          }
          return false;
        },
        placeholderCaption() {
          return this.field("caption", {}).placeholder;
        },
        placeholderText() {
          return this.field("text", {}).placeholder;
        }
      },
      methods: {
        focus() {
          this.$refs.text.focus();
        }
      },
      template: `
        <template>
          <div>
            <img @dblclick="open" v-if="media"
              :src="media"
            >
            <k-writer
              :inline="true"
              :placeholder="placeholderText"
              :value="content.text"
              class="k-block-type-testimonial-text"
              ref="text"
              @input="update({ text: $event })"
            />
            <k-writer
              :inline="true"
              :placeholder="placeholderCaption"
              :value="content.caption"
              class="k-block-type-testimonial-caption"
              @input="update({ caption: $event })"
            />
          </div>
        </template>
      `
    }
  }
});