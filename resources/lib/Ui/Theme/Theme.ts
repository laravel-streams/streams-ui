import { UIManager } from '../UIManager';
import { Join, PathsToStringProps } from '../../Core/types/helpers';
import { getSetDescendantProp } from '../../Core';
import { black, c, DotNotatedColorKeys, green, lightBlue, orange, red, white } from './colors';
import { Color } from './Color';
import { darken } from './utils';

export abstract class Theme {
    abstract name: string;
    extends?: typeof Theme;

    palette       = {
        primary: c('white'),
        success: c('green.300'),
        info   : c('lightBlue.400'),
        warning: c('orange.300'),
        danger : c('red.300'),
    };
    base          = {
        font_color      : black,
        background_color: white,
        font_size       : '16px',
        font_family     : `'Inter', sans-serif`,
    };
    ui_toolbar    = {
        height    : v('ui_toolbar_height'),
        background: v('ui_toolbar_background'),
        color     : v('ui_toolbar_color'),
    };
    ui_cp         = {};
    ui_cp_sidebar = {
        width     : v('ui_cp_sidebar_width'),
        background: v('ui_cp_sidebar_background'),
        color     : v('ui_cp_sidebar_color'),
    };
    ui_cp_header  = {
        height    : v('ui_cp_header_height'),
        background: v('ui_cp_header_background'),
        color     : v('ui_color'),
    };
    ui_alert      = {
        label_size        : v('ui_alert_label_size'),
        message_size      : v('ui_alert_message_size'),
        success_background: v('ui_alert_success_background'),
        success_color     : v('ui_alert_success_color'),
        info_background   : v('ui_alert_info_background'),
        info_color        : v('ui_alert_info_color'),
        warning_background: v('ui_alert_warning_background'),
        warning_color     : v('ui_alert_warning_color'),
        danger_background : v('ui_alert_danger_background'),
        danger_color      : v('ui_alert_danger_color'),
    };

    constructor(protected ui: UIManager) {

    }

    abstract onLoad();

    var(name: Variable) {return v(name); }

    get(key: DotNotatedThemeKeys) {return t(key);}

    color(key: DotNotatedColorKeys): Color {return c(key);}
}

const palette = {
    font      : black,
    background: white,

    primary: white,
    success: green[ '300' ],
    info   : lightBlue[ '400' ],
    warning: orange[ '300' ],
    danger : red[ '300' ],
};

const base = {
    font_color      : black,
    background_color: white,
    font_size       : '16px',
    font_family     : `'Inter', sans-serif`,
};

type BaseVariables = typeof base
type BaseVariable = keyof BaseVariables
const b = (key: BaseVariable): string => `var(--${key.replace('_', '-')}, ${base[ key ]})`;

const variables = {
    ui_color           : black,
    ui_background_color: white,

    ui_cp_header_height    : '50px',
    ui_cp_header_background: white,

    ui_cp_sidebar_width     : '300px',
    ui_cp_sidebar_background: black,
    ui_cp_sidebar_color     : white,

    ui_toolbar_height    : '50px',
    ui_toolbar_background: white,
    ui_toolbar_color     : black,

    ui_alert_label_size        : '20px',
    ui_alert_message_size      : base.font_size,
    ui_alert_success_background: palette.success,
    ui_alert_success_color     : darken(palette.success, 0.7),
    ui_alert_info_background   : palette.info,
    ui_alert_info_color        : darken(palette.info, 0.7),
    ui_alert_warning_background: palette.warning,
    ui_alert_warning_color     : darken(palette.warning, 0.7),
    ui_alert_danger_background : palette.danger,
    ui_alert_danger_color      : darken(palette.danger, 0.7),
};

type Variables = typeof variables
type Variable = keyof Variables
const v = (key: Variable): string => `var(--${key.replace('_', '-')}, ${variables[ key ]})`;


export const theme = {
    ui           : {
        color           : v('ui_color'),
        background_color: v('ui_background_color'),
    },
    ui_toolbar   : {
        height    : v('ui_toolbar_height'),
        background: v('ui_toolbar_background'),
        color     : v('ui_toolbar_color'),
    },
    ui_cp        : {},
    ui_cp_sidebar: {
        width     : v('ui_cp_sidebar_width'),
        background: v('ui_cp_sidebar_background'),
        color     : v('ui_cp_sidebar_color'),
    },
    ui_cp_header : {
        height    : v('ui_cp_header_height'),
        background: v('ui_cp_header_background'),
        color     : v('ui_color'),
    },
    ui_alert     : {
        label_size        : v('ui_alert_label_size'),
        message_size      : v('ui_alert_message_size'),
        success_background: v('ui_alert_success_background'),
        success_color     : v('ui_alert_success_color'),
        info_background   : v('ui_alert_info_background'),
        info_color        : v('ui_alert_info_color'),
        warning_background: v('ui_alert_warning_background'),
        warning_color     : v('ui_alert_warning_color'),
        danger_background : v('ui_alert_danger_background'),
        danger_color      : v('ui_alert_danger_color'),
    },
};
export type DotNotatedThemeKeys = Join<PathsToStringProps<typeof theme>, '.'>
export const t = (key: DotNotatedThemeKeys) => getSetDescendantProp(theme, key);

export class DefaultTheme extends Theme {
    name: 'default';

    public onLoad() {

    }
}
