// GitHub Docs Plugin JavaScript

document.addEventListener('DOMContentLoaded', function() {
  // Add sync functionality for github-docs pages
  if (window.location.pathname.includes('/panel/pages/') && 
      document.querySelector('[data-template="github-docs"]')) {
    addSyncButton();
  }
});

function addSyncButton() {
  // Find the info field that shows sync instructions
  const infoField = document.querySelector('[data-field="sync_button"]');
  if (!infoField) return;
  
  // Create sync button
  const syncButton = document.createElement('button');
  syncButton.className = 'k-button k-button-filled';
  syncButton.innerHTML = '🔄 Sync Now';
  syncButton.onclick = performSync;
  
  // Add button after the info text
  const infoText = infoField.querySelector('.k-info-text');
  if (infoText) {
    infoText.appendChild(document.createElement('br'));
    infoText.appendChild(document.createElement('br'));
    infoText.appendChild(syncButton);
  }
}

async function performSync() {
  const button = event.target;
  const originalText = button.innerHTML;
  
  // Get page slug from URL
  const pathParts = window.location.pathname.split('/');
  const pageSlug = pathParts[pathParts.length - 1];
  
  try {
    button.innerHTML = '⏳ Syncing...';
    button.disabled = true;
    
    const response = await fetch('/api/github-docs/sync', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF': document.querySelector('meta[name="csrf"]')?.content || ''
      },
      body: JSON.stringify({
        parent: pageSlug
      })
    });
    
    const result = await response.json();
    
    if (result.error) {
      throw new Error(result.error);
    }
    
    // Show success message
    button.innerHTML = '✅ Sync Complete!';
    
    // Show sync results
    const message = `
      Sync completed successfully:
      • Created: ${result.created || 0} pages
      • Updated: ${result.updated || 0} pages  
      • Deleted: ${result.deleted || 0} pages
      ${result.errors?.length ? '\n• Errors: ' + result.errors.length : ''}
    `;
    
    alert(message);
    
    // Reload page to show updated content
    setTimeout(() => {
      window.location.reload();
    }, 2000);
    
  } catch (error) {
    button.innerHTML = '❌ Sync Failed';
    alert('Sync failed: ' + error.message);
    
    setTimeout(() => {
      button.innerHTML = originalText;
      button.disabled = false;
    }, 3000);
  }
}
