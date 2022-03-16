import { cssRule, fontFace,style } from 'typestyle';
import { b } from './variables';
import { normalize as addNormalize, setupPage } from 'csstips';
import { constants } from '../constants';

const { fontPath, normalize, rootSelector } = constants;

if ( normalize ) {
    addNormalize();
}

setupPage(rootSelector);

fontFace({
    fontFamily: 'Inter Semi',
    src       : `url('${fontPath}/Inter-SemiBold.woff2') format('woff2'),
                 url('${fontPath}/Inter-SemiBold.woff') format('woff');`,
    fontWeight: 600,
    fontStyle : 'normal',
});

fontFace({
    fontFamily: 'Inter',
    src       : `url('${fontPath}/Inter-Regular.woff2') format('woff2'),
                 url('${fontPath}/Inter-Regular.woff') format('woff');`,
    fontWeight: 'normal',
    fontStyle : 'normal',
});
cssRule('html, body', {
    height  : '100%',
    width   : '100%',
    fontSize: b('font_size'),
    margin  : 0,
    padding : 0,
});
cssRule('body', {
    color          : b('font_color'),
    backgroundColor: b('background_color'),
    fontFamily     : b('font_family')
});
