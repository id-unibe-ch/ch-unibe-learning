panel.plugin("tfk/block-pricing", {
  blocks: {
    pricing: {
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
        empty() {
          if (!this.content.buttontext && !this.content.features && !this.content.heading && !this.content.iconimage[0] && !this.content.price && !this.content.text) {
            return true;
          }
          return false;
        },
        marksHeading() {
          return this.field("heading", {}).marks;
        },
        marksPrice() {
          return this.field("price", {}).marks;
        },
        marksPriceDetails() {
          return this.field("pricedetails", {}).marks;
        },
        marksTag() {
          return this.field("tag", {}).marks;
        }
      },
      template: `
        <template>
          <div
            :class="classes"
          >
            <div @click="open" v-if="empty" class="k-block-figure-empty-add">Add pricing...</div>
            <div v-else>
              <img @dblclick="open" v-if="this.content.iconimage[0]"
                :src="this.content.iconimage[0].url"
              >
              <k-writer v-if="this.content.tag"
                :inline="true"
                :marks="marksTag"
                :value="content.tag"
                class="k-block-type-pricing-tag"
                @input="update({ tag: $event })"
              />
              <k-writer v-if="this.content.heading"
                :inline="true"
                :marks="marksHeading"
                :value="content.heading"
                class="k-block-type-pricing-heading"
                @input="update({ heading: $event })"
              />
              <div class="k-block-type-pricing-price-wrapper">
                <k-writer v-if="this.content.price"
                  :inline="true"
                  :marks="marksPrice"
                  :value="content.price"
                  class="k-block-type-pricing-price"
                  @input="update({ price: $event })"
                />
                <k-writer v-if="this.content.pricedetails"
                  :inline="true"
                  :marks="marksPriceDetails"
                  :value="content.pricedetails"
                  class="k-block-type-pricing-price-details"
                  @input="update({ pricedetails: $event })"
                />
              </div>
              <k-writer v-if="this.content.text"
                :inline="true"
                :value="content.text"
                class="k-block-type-pricing-text"
                @input="update({ text: $event })"
              />
              <k-input v-if="this.content.features"
                :value="content.features"
                class="k-block-type-pricing-features"
                type="list"
                @input="update({ features: $event })"
              />
              <button @dblclick="open" v-if="this.content.buttontext"
                :class="classesButton"
                type="button"
              >
                {{ content.buttontext }}
              </button>
            </div>
          </div>
        </template>
      `
    }
  }
});