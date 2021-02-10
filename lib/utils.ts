export function discoverAndInitialize(){
    window.Alpine.discoverUninitializedComponents(window.Alpine.initializeComponent)
}
