panel.plugin("tfk/block-code", {
  blocks: {
    code: {
      computed: {
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
              :placeholder="placeholder"
              :spellcheck="false"
              :value="content.text"
              class="k-block-type-code-text"
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