panel.plugin("tfk/block-line", {
  blocks: {
    line: {
      computed: {
        classes() {
          return "k-block-align-" + this.content.aligncontent;
        },
        classesLine() {
          if (this.content.fullwidth === true) {
            return "k-block-type-line-" + this.content.style + " k-block-full-width";
          }
          return "k-block-type-line-" + this.content.style;
        }
      },
      template: `
        <template>
          <div
            :class="classes"
          >
            <hr @dblclick="open"
              :class="classesLine"
            />
          </div>
        </template>
      `
    }
  }
});