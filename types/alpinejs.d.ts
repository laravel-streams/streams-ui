declare module 'alpinejs' {
    const alpinejs: AlpineJS;
    export default alpinejs;
}

export interface AlpineJS {
    addMagicProperty: (name: string, callback: Function) => void
    clone: (component: any, targetElement: Element) => any
    discoverComponents: (callback: (el: HTMLElement) => void) => void
    discoverUninitializedComponents: (callback: (el: HTMLElement) => void, element?: Element) => void
    ignoreFocusedForValueBinding: boolean
    /**
     * @throws Error
     * @param element
     */
    initializeComponent: (element: Element) => void
    listenForNewUninitializedComponentsAtRunTime: () => void
    magicProperties: Record<string, Function>
    onBeforeComponentInitialized: (callback: Function) => void
    onBeforeComponentInitializeds: []
    onComponentInitialized: (callback: Function) => void
    onComponentInitializeds: []
    pauseMutationObserver: boolean
    start: () => Promise<any>
    version: string
}

export interface Window {
    Alpine: AlpineJS
}

const alpinejs: AlpineJS;
export default alpinejs;
