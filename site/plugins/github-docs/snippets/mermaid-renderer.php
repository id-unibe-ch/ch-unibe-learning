<?php 
/**
 * Mermaid Diagram Renderer Snippet
 * This snippet provides Mermaid diagram rendering functionality
 */

// Initialize Mermaid if not already done
if (!isset($mermaidInitialized) || !$mermaidInitialized): 
  $mermaidInitialized = true;
?>

<!-- Mermaid CSS and JS -->
<script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
<style>
.mermaid-container {
  margin: 2rem 0;
  text-align: center;
}

.mermaid-diagram {
  display: inline-block;
  max-width: 100%;
  overflow-x: auto;
  background: white;
  border: 1px solid #e1e4e8;
  border-radius: 6px;
  padding: 1rem;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.mermaid-title {
  font-weight: 600;
  margin-bottom: 1rem;
  color: #24292e;
}

.mermaid-error {
  background: #fff5f5;
  border: 1px solid #feb2b2;
  color: #c53030;
  padding: 1rem;
  border-radius: 4px;
  margin: 1rem 0;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
  .mermaid-diagram {
    background: #1a1a1a;
    border-color: #444;
  }
}
</style>

<script>
// Initialize Mermaid with configuration
mermaid.initialize({
  startOnLoad: true,
  theme: window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'default',
  themeVariables: {
    fontFamily: 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
    fontSize: '14px'
  },
  flowchart: {
    useMaxWidth: true,
    htmlLabels: true,
    curve: 'basis'
  },
  sequence: {
    useMaxWidth: true,
    diagramMarginX: 50,
    diagramMarginY: 10,
    actorMargin: 50,
    width: 150,
    height: 65,
    boxMargin: 10,
    boxTextMargin: 5,
    noteMargin: 10,
    messageMargin: 35
  },
  gantt: {
    useMaxWidth: true,
    barHeight: 20,
    fontSize: 11,
    sectionFontSize: 11,
    numberSectionStyles: 4
  }
});

// Handle rendering errors gracefully
window.addEventListener('DOMContentLoaded', function() {
  const mermaidElements = document.querySelectorAll('.mermaid');
  
  mermaidElements.forEach(function(element) {
    try {
      // Add error handling wrapper
      const originalContent = element.textContent;
      element.addEventListener('error', function() {
        element.innerHTML = '<div class="mermaid-error">Error rendering diagram: ' + originalContent + '</div>';
      });
    } catch (error) {
      console.warn('Mermaid rendering error:', error);
    }
  });
});

// Support for dynamic theme switching
function updateMermaidTheme(isDark) {
  mermaid.initialize({
    theme: isDark ? 'dark' : 'default'
  });
  
  // Re-render existing diagrams
  document.querySelectorAll('.mermaid').forEach(function(element) {
    if (element.getAttribute('data-processed') === 'true') {
      element.removeAttribute('data-processed');
      mermaid.init(undefined, element);
    }
  });
}

// Listen for theme changes
if (window.matchMedia) {
  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
    updateMermaidTheme(e.matches);
  });
}
</script>

<?php endif; ?>

<?php
/**
 * Render a Mermaid diagram
 * 
 * @param string $diagram The Mermaid diagram code
 * @param string $title Optional title for the diagram
 * @param string $id Optional unique ID for the diagram
 */
function renderMermaidDiagram($diagram, $title = null, $id = null) {
  $diagramId = $id ?: 'mermaid-' . uniqid();
  $cleanDiagram = trim($diagram);
  
  echo '<div class="mermaid-container">';
  
  if ($title) {
    echo '<div class="mermaid-title">' . htmlspecialchars($title) . '</div>';
  }
  
  echo '<div class="mermaid" id="' . htmlspecialchars($diagramId) . '">';
  echo htmlspecialchars($cleanDiagram);
  echo '</div>';
  echo '</div>';
}

/**
 * Process markdown content to render Mermaid diagrams
 * 
 * @param string $content Markdown content
 * @return string Processed content with Mermaid diagrams
 */
function processMermaidInMarkdown($content) {
  // Process ```mermaid code blocks
  $content = preg_replace_callback(
    '/```mermaid(?:\s+(.+?))?\s*\n(.*?)\n```/s',
    function($matches) {
      $title = isset($matches[1]) ? trim($matches[1]) : null;
      $diagram = trim($matches[2]);
      $id = 'mermaid-' . md5($diagram);
      
      ob_start();
      renderMermaidDiagram($diagram, $title, $id);
      return ob_get_clean();
    },
    $content
  );
  
  return $content;
}
?>
