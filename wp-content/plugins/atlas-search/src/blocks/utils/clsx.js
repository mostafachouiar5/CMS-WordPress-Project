function clsx(...args) {
  return args
    .flatMap((arg) => {
      if (typeof arg === 'string' || typeof arg === 'number') {
        return [arg];
      }

      if (Array.isArray(arg)) {
        return clsx(...arg);
      }

      if (typeof arg === 'object' && arg !== null) {
        return Object.keys(arg).filter((key) => arg[key]);
      }

      return [];
    })
    .filter(Boolean)
    .join(' ');
}
export default clsx;
