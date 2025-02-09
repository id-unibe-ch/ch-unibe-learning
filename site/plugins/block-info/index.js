panel.plugin("tfk/block-info", {
  blocks: {
    info: {
      computed: {
        classesText() {
          return "k-block-type-info-text k-block-type-info-" + this.content.context;
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
            <k-writer
              :class="classesText"
              :inline="true"
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