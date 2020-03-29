
//变量输出
const user = 'Brown!';
const qty  = 'test';
const event = 'Select!';
console.log(
    `Hey,${user},Thanks for ordering ${qty} tickets to ${event}.
`);

//析构赋值
const userMap = {name : 'Brown',age:18};

const { name , age } = userMap;
console.log(name,age);  // Brown 18

const arrMap = ['orders','detail'];

const [first,second] = arrMap;

console.log(first,second);   //orders detail

console.log([...arrMap,'hello world!']);   //组装数组


//箭头函数

let c = 5;

var fn = x => x*x;

console.log(fn(c));