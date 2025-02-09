panel.plugin("tfk/block-quote", {
  blocks: {
    quote: {
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
            <k-writer
              :inline="true"
              :placeholder="placeholder"
              :value="content.text"
              class="k-block-type-quote-text"
              ref="text"
              @input="update({ text: $event })"
            />
            <k-writer v-if="this.content.caption"
              :inline="true"
              :value="content.caption"
              class="k-block-type-quote-caption"
              @input="update({ caption: $event })"
            />
          </div>
        </template>
      `
    }
  }
});