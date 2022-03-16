import { inject, injectable } from '../Core';
import { DefinitionCollection, ElementCollection } from './Support';
import { ThemeManager } from './Theme';

@injectable()
export class UIManager {
    elements: ElementCollection       = new ElementCollection();
    definitions: DefinitionCollection = new DefinitionCollection();
    @inject('themes') themes: ThemeManager;
}

