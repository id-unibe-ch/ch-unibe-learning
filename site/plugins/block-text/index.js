panel.plugin("tfk/block-text", {
  blocks: {
    text: {
      computed: {
        classes() {
          return "k-block-align-" + this.content.aligncontent;
        },
        placeholder() {
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
          <div
            :class="classes"
          >
            <k-writer
              :placeholder="placeholder"
              :value="content.text"
              ref="text"
              @input="update({ text: $event })"
            />
          </div>
        </template>
      `
    }
  }
});