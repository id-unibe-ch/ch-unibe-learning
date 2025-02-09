panel.plugin("tfk/block-markdown", {
  blocks: {
    markdown: {
      computed: {
        classesText() {
          return "k-block-type-markdown-text";
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
          <div>
            <k-input
              :buttons="false"
              :class="classesText"
              :placeholder="placeholder"
              :value="content.text"
              ref="text"
              type="textarea"
              @input="update({ text: $event })"
            />
          </div>
        </template>
      `
    }
  }
});