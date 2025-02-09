panel.plugin("tfk/block-heading", {
  blocks: {
    heading: {
      computed: {
        classes() {
          return "k-block-align-" + this.content.aligncontent;
        },
        classesLabel() {
          return "k-block-type-heading-label-" + this.content.fontsize + " k-block-type-heading-label-style-" + this.content.labelstyle;
        },
        classesText() {
          return "k-block-type-heading-" + this.content.fontsize;
        },
        marksLabel() {
          return this.field("label", {}).marks;
        },
        marksText() {
          return this.field("text", {}).marks;
        },
        optionsFontSize() {
          return this.field("fontsize", { options: [] }).options;
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
            <div class="k-block-type-heading-wrapper">
              <k-writer v-if="this.content.label && this.content.labelposition === 'top'"
                :class="classesLabel"
                :inline="true"
                :marks="marksLabel"
                :value="content.label"
                @input="update({ label: $event })"
              />
              <k-writer
                :class="classesText"
                :inline="true"
                :marks="marksText"
                :placeholder="placeholder"
                :value="content.text"
                ref="text"
                @input="update({ text: $event })"
              />
              <k-writer v-if="this.content.label && this.content.labelposition === 'bottom'"
                :class="classesLabel"
                :inline="true"
                :marks="marksLabel"
                :value="content.label"
                @input="update({ label: $event })"
              />
            </div>
            <k-input v-if="optionsFontSize.length > 1"
              :empty="false"
              :options="optionsFontSize"
              :value="content.fontsize"
              type="select"
              @input="update({ fontsize: $event })"
            />
          </div>
        </template>
      `
    }
  }
});