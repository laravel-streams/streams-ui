import { black, green, lightBlue, orange, red, white } from './colors';
import { darken } from './utils';

export const colors = {
    primary: white,
    success: green[ '500' ],
    info   : lightBlue[ '500' ],
    warning: orange[ '500' ],
    danger : red[ '500' ],
};

export const base = {
    font_color      : black,
    background_color: white,
    font_size       : '16px',
    font_family     : `'Inter', sans-serif`,
};

export type BaseVariables = typeof base
export type BaseVariable = keyof BaseVariables
export const b = (key: BaseVariable): string => `var(--${key.replace('_', '-')}, ${base[ key ]})`;

export const variables = {
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

    ui_alert_label_size        : '30px',
    ui_alert_message_size      : base.font_size,
    ui_alert_success_background: colors.success,
    ui_alert_success_color     : darken(colors.success, 0.5),
    ui_alert_info_background   : colors.info,
    ui_alert_info_color        : colors.info,
    ui_alert_warning_background: colors.warning,
    ui_alert_warning_color     : colors.warning,
    ui_alert_danger_background : colors.danger,
    ui_alert_danger_color      : colors.danger,
};

export type Variables = typeof variables
export type Variable = keyof Variables
export const v = (key: Variable): string => `var(--${key.replace('_', '-')}, ${variables[ key ]})`;
