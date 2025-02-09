panel.plugin("tfk/block-youtube", {
  blocks: {
    youtube: {
      computed: {
        url() {
          if (this.content.url) {
            var url = this.content.url;
            var youtubePattern = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            var youtubeMatch = url.match(youtubePattern);
            if (youtubeMatch) {
              return "https://www.youtube.com/embed/" + youtubeMatch[2];
            }
          }
          return false;
        }
      },
      template: `
        <template>
          <div class="k-block-full-width">
            <iframe v-if="url"
              :src="url"
            />
            <figure @dblclick="open" v-else class="k-block-figure">
              <button class="k-block-figure-empty k-button" type="button">
                <span aria-hidden="true" class="k-button-icon k-icon k-icon-youtube">
                  <svg viewBox="0 0 16 16"><use xlink:href="#icon-youtube"></use></svg>
                </span>
                <span class="k-button-text">Link to video...</span>
              </button>
            </figure>
          </div>
        </template>
      `
    }
  }
});