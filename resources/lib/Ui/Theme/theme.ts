import { v } from './variables';


export interface ThemeVariations {
    default: string;
    dark: string;
    light: string;
}

export type ThemeVariation = keyof ThemeVariations

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

