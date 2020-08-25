---
title: Builders
category: core_concepts
intro: 
sort: 10
---

- **Intro:** Introduce the idea in one sentance.
    - Builders are classes that help you quickly build up UI component objects.
- **Explaination:** An elevator pitch that signals the reader to continue or not (keep looking for relavant page).
    - Build Components
- **Sections/Features:** Separate sections/sub-sections (h2s/h3s) consistently. This will build the ToC.
    - Configuration
        - stream
    - Basic Usage
        - Rendering Components
    - Component Responses
        - JSON Responses
- **Next Steps:** Next actions to take that are intentional versus simply additional reading.
    - Build a Table
    - Build a Form
- **Code Examples:** Code examples and snippets.
- **Insights:** Tips, post scriptum, creative links.
- **Additional Reading:** Link to related ideas/topics/guides/recipes.
    - Tables
    - Forms
    - Buttons
    - Icons


# Configuration Examples

```json
{
    "form": [
        "component",    // The component type handle
        "{form}",       // The component abstract to use

        "template",     // The component view template (falls back to ui::component/component)
        "assets"        // Assets array by collection to load upon invokation of the component.
    ],
    "table": {

    }
}
```
