export function ThousandSeperator(number) {
  return Number(number).toString().replace(/\B(?=(\d{3})+(?!\d))/g, Number(10000).toLocaleString().substring(2, 3))
}
export function PriceFormatter(price) {
  return '$' + ThousandSeperator(price)
}
export function KilometerFormatter(km) {
  return ThousandSeperator(km) + ' Km'
}
export function DateFormatter(date) {
  return moment(date).format('MMM D YYYY')
}
