panel.plugin("tfk/block-list", {
  blocks: {
    list: {
      computed: {
        classes() {
          return "k-block-align-" + this.content.aligncontent;
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
            <k-input
              :value="content.text"
              class="k-block-type-list-text"
              ref="text"
              type="list"
              @input="update({ text: $event })"
            />
          </div>
        </template>
      `
    }
  }
});