---
title: Overview
category: tables
sort: 0
---

- **Intro:** Introduce the idea in one sentance.
- **Explaination:** An elevator pitch that signals the reader to continue or not (keep looking for relavant page).
    - Table builders help you quickly build up table components.
- **Sections/Features:** Separate sections/sub-sections (h2s/h3s) consistently. This will build the ToC.
    - Basic Usage
    - Configuring Tables
- **Next Steps:** Next actions to take that are intentional versus simply additional reading.
- **Code Examples:** Code examples and snippets.
- **Insights:** Tips, post scriptum, creative links.
- **Additional Reading:** Link to related ideas/topics/guides/recipes.


# Configuration Examples

```json
{
    "form": [
        // Required Configuration
        "stream",   // The stream the entry belongs to
        
        // Optional Configuration
        "repository",   // The entry repository

        "builder",  // The table builder to use
        "table",    // The table component to use
        
        "assets",   // Assets to load
        
        "views",        // Table views configuration
        "filters",      // Table filters configuration
        "columns",      // Table columns configuration
        "actions",      // Table actions configuration
        "buttons",      // Table buttons configuration
        
        "options": [    // Component options array
            "sortable" // Enable sortable functionality
        ]
    ],
}
```
