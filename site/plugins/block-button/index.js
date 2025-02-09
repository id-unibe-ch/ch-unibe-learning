panel.plugin("tfk/block-button", {
  blocks: {
    button: {
      computed: {
        classes() {
          return "k-block-align-" + this.content.aligncontent;
        },
        classesButton() {
          if (this.content.fullwidth === true) {
            return "k-block-button k-block-button-style-" + this.content.style + " k-block-full-width";
          }
          return "k-block-button k-block-button-style-" + this.content.style;
        },
        contentText() {
          if (this.content.text) {
            return this.content.text;
          }
          return this.field("text", {}).placeholder;
        }
      },
      template: `
        <template>
          <div
            :class="classes"
          >
            <button @dblclick="open"
              :class="classesButton"
              type="button"
            >
              {{ contentText }}
            </button>
          </div>
        </template>
      `
    }
  }
});