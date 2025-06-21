panel.plugin("unibe/asciidoc-converter", {
  // Panel plugin for AsciiDoc Converter
  
  // Add menu item to admin panel
  created() {
    // Check if user has admin privileges
    if (this.$store.state.user.user?.role === 'admin') {
      this.addMenuItem();
    }
  },
  
  methods: {
    addMenuItem() {
      // Add converter option to the panel menu
      // This would integrate with Kirby's panel interface
      console.log('AsciiDoc Converter plugin loaded');
    },
    
    async scanFiles() {
      try {
        const response = await this.$api.get('asciidoc-converter/scan');
        return response;
      } catch (error) {
        this.$store.dispatch('notification/error', 'Failed to scan for AsciiDoc files');
        throw error;
      }
    },
    
    async convertFiles(options = {}) {
      try {
        const response = await this.$api.post('asciidoc-converter/convert', {
          path: options.path || '',
          recursive: options.recursive !== false,
          backup: options.backup !== false
        });
        
        this.$store.dispatch('notification/success', 
          `Converted ${response.stats.converted} files successfully`
        );
        
        if (response.stats.errors.length > 0) {
          this.$store.dispatch('notification/error', 
            `${response.stats.errors.length} files had conversion errors`
          );
        }
        
        return response;
      } catch (error) {
        this.$store.dispatch('notification/error', 'Conversion failed');
        throw error;
      }
    }
  }
});
