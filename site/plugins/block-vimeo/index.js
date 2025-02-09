panel.plugin("tfk/block-vimeo", {
  blocks: {
    vimeo: {
      computed: {
        url() {
          if (this.content.url) {
            var url = this.content.url;
            var vimeoPattern = /vimeo\.com\/([0-9]+)/;
            var vimeoMatch = url.match(vimeoPattern);
            if (vimeoMatch) {
              return "https://player.vimeo.com/video/" + vimeoMatch[1];
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
                <span aria-hidden="true" class="k-button-icon k-icon k-icon-vimeo">
                  <svg viewBox="0 0 16 16"><use xlink:href="#icon-vimeo"></use></svg>
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