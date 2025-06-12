panel.plugin("unibe/block-test", {
  blocks: {
    test: `
      <div @click="open">
        {{ content.text }}
      </div>
    `,
    // more blocks
  }
});