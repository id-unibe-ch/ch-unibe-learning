panel.plugin("tfk/block-video", {
  blocks: {
    video: {
      computed: {
        media() {
          if (this.content.media[0]) {
            return this.content.media[0].url;
          }
          return false;
        }
      },
      template: `
        <template>
          <div class="k-block-full-width">
            <video v-if="media" controls>
              <source
                :src="media"
              >
            </video>
            <figure @dblclick="open" v-else class="k-block-figure">
              <button class="k-block-figure-empty k-button" type="button">
                <span aria-hidden="true" class="k-button-icon k-icon k-icon-video">
                  <svg viewBox="0 0 16 16"><use xlink:href="#icon-video"></use></svg>
                </span>
                <span class="k-button-text">Select media...</span>
              </button>
            </figure>
          </div>
        </template>
      `
    }
  }
});