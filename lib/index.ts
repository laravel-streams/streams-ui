// import '../scss/theme.scss'
// import '../scss/variables.scss'
// import '../scss/inputs/markdown.scss'
// import '../scss/inputs/markdown.scss'
import 'reflect-metadata';

import './../resources/scss/variables.scss';
import './../resources/scss/theme.scss';

import 'alpinejs';

export * from './types';
export * from './ExampleClass';
export * from './UiServiceProvider';
export * from './Input';

export async function testAtest() {
    let { atest } = await import('./atest');
    atest();
}

//window.streams.ui[UiServiceProvider.name] = UiServiceProvider;
