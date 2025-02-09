panel.plugin("tfk/block-blurb", {
  blocks: {
    blurb: {
      computed: {
        classes() {
          return "k-block-align-" + this.content.aligncontent;
        },
        classesButton() {
          if (this.content.buttonfullwidth === true) {
            return "k-block-button k-block-button-style-" + this.content.buttonstyle + " k-block-full-width";
          }
          return "k-block-button k-block-button-style-" + this.content.buttonstyle;
        },
        classesHeading() {
          return "k-block-type-blurb-heading";
        },
        classesTag() {
          return "k-block-type-blurb-tag";
        },
        marksHeading() {
          return this.field("heading", {}).marks;
        },
        marksTag() {
          return this.field("tag", {}).marks;
        },
        media() {
          if (this.content.iconimage[0]) {
            return this.content.iconimage[0].url;
          }
          return false;
        },
        placeholder() {
          return this.field("heading", {}).placeholder;
        }
      },
      methods: {
        focus() {
          this.$refs.heading.focus();
        }
      },
      template: `
        <template>
          <div
            :class="classes"
          >
            <img @dblclick="open" v-if="media"
              :src="media"
            >
            <k-writer v-if="this.content.tag"
              :class="classesTag"
              :inline="true"
              :marks="marksTag"
              :value="content.tag"
              @input="update({ tag: $event })"
            />
            <k-writer
              :class="classesHeading"
              :inline="true"
              :marks="marksHeading"
              :placeholder="placeholder"
              :value="content.heading"
              ref="heading"
              @input="update({ heading: $event })"
            />
            <k-writer v-if="this.content.text"
              :inline="true"
              :value="content.text"
              @input="update({ text: $event })"
            />
            <button @dblclick="open" v-if="this.content.buttontext"
              :class="classesButton"
              type="button"
            >
              {{ content.buttontext }}
            </button>
          </div>
        </template>
      `
    }
  }
});