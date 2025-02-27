export const decodeBase64 = (value) => {
  const isBase64 = /^data:image\/(png|jpeg|jpg|gif|webp|svg+xml);base64,/.test(
    value
  );
  return isBase64 ? value : `data:image/*;base64,${value}`;
};
