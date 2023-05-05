import dayjs from 'dayjs';

/**
 *
 * @param {String} timeString
 * @param {String} format
 * @see https://day.js.org/docs/en/display/format
 * @returns {string}
 */
export const formatTime = (timeString, format = 'hh:mm:A') => {

    if (!dayjs(timeString).isValid()) {
        throw new Error('Invalid Timestamp');
    }

    return dayjs(timeString).format(format);
};

export const formatDate = (timeString, format = 'DD-MMM-YYYY') => {
    return formatTime(timeString, format);
};

/**
 *
 * @param { String } timestamp - timestamp
 * @param { Object } config - date time formatter and separator
 * @param { String } config.timeFormat - time formatter
 * @param { String } config.dateFormatter - date formatter
 * @param { String } config.separator - date time separator
 * @see https://day.js.org/docs/en/display/format
 * @return string
 */
export const formatDateTime = (timestamp, config = {}) => {

    const defaultConfig = {
        timeFormat: undefined,
        dateFormat: undefined,
        separator: 'at',
        ...config
    };

    const date = formatDate(timestamp, defaultConfig.dateFormat);
    const time = formatTime(timestamp, defaultConfig.timeFormat);

    return `${ date } ${ defaultConfig.separator } ${ time }`;
};