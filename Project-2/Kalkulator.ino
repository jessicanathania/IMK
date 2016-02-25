/*
  LiquidCrystal Library - Hello World
 
 Demonstrates the use a 16x2 LCD display.  The LiquidCrystal
 library works with all LCD displays that are compatible with the 
 Hitachi HD44780 driver. There are many of them out there, and you
 can usually tell them by the 16-pin interface.
 
 This sketch prints "Hello World!" to the LCD
 and shows the time.
 
  The circuit:
 * LCD RS pin to digital pin 12
 * LCD Enable pin to digital pin 11
 * LCD D4 pin to digital pin 5
 * LCD D5 pin to digital pin 4
 * LCD D6 pin to digital pin 3
 * LCD D7 pin to digital pin 2
 * LCD R/W pin to ground
 * LCD VSS pin to ground
 * LCD VCC pin to 5V
 * 10K resistor:
 * ends to +5V and ground
 * wiper to LCD VO pin (pin 3)
 
 Library originally added 18 Apr 2008
 by David A. Mellis
 library modified 5 Jul 2009
 by Limor Fried (http://www.ladyada.net)
 example added 9 Jul 2009
 by Tom Igoe
 modified 22 Nov 2010
 by Tom Igoe
 
 This example code is in the public domain.

 http://www.arduino.cc/en/Tutorial/LiquidCrystal
 */

// include the library code:
#include <LiquidCrystal.h>
#include <Keypad.h>
const byte ROWS = 4; //4 rows
const byte COLS = 4; //3 columns
//Define the Keymap
char keys[ROWS][COLS] = {
  {'1','2','3','+'},
  {'4','5','6','-'},
  {'7','8','9','*'},
  {'C','0','=','/'}
};
//Connect keypad ROW0, ROW1, ROW2, and ROW3 to these arduino pins
byte rowPins[ROWS] = {0, 1, 2, 3 };
//Connect Keypad COL0, COL1, COL2 to these arduino pins
byte colPins[COLS] = {A4, A3, A2, A1};

long first = 0;
long second = 0;
double total = 0;

//Create the keypad
Keypad kpd = Keypad (makeKeymap(keys), rowPins, colPins, ROWS, COLS);

// initialize the library with the numbers of the interface pins
LiquidCrystal lcd(8, 9, 4, 5, 6, 7);


void setup() {
  // set up the LCD's number of columns and rows: 
  lcd.begin(16, 2);
  // Print a message to the LCD.
  //lcd.print("hello, world!");
}

void loop() {
  char key = kpd.getKey();/*
  if (key) //Check for valid key
  {
  // set the cursor to column 0, line 1
  // (note: line 1 is the second row, since counting begins with 0):
  lcd.setCursor(0, 1);
  // print the number of seconds since reset:
  lcd.print(key);
  }*/
  
  switch(key) 
  {
  case '0' ... '9': // This keeps collecting the first value until a operator is pressed "+-*/"
    lcd.setCursor(0,0);
    first = first * 10 + (key - '0');
    lcd.print(first);
    break;

  case '+':
    first = (total != 0 ? total : first);
    lcd.setCursor(0,1);
    lcd.print("+");
    second = SecondNumber(); // get the collected the second number
    total = first + second;
    lcd.setCursor(0,3);
    lcd.print(total);
    lcd.setCursor(0,0);
    lcd.print("Hasil:");
    first = 0, second = 0; // reset values back to zero for next use
    break;

  case '-':
    first = (total != 0 ? total : first);
    lcd.setCursor(0,1);
    lcd.print("-");
    second = SecondNumber();
    total = first - second;
    lcd.setCursor(0,3);
    lcd.print(total);
    lcd.setCursor(0,0);
    lcd.print("Hasil:");
    first = 0, second = 0;
    break;

  case '*':
    first = (total != 0 ? total : first);
    lcd.setCursor(0,1);
    lcd.print("*");
    second = SecondNumber();
    total = first * second;
    lcd.setCursor(0,3);
    lcd.print(total);
    lcd.setCursor(0,0);
    lcd.print("Hasil:");
    first = 0, second = 0;
    break;

  case '/':
    first = (total != 0 ? total : first);
    lcd.setCursor(0,1);
    lcd.print("/");
    second = SecondNumber();
    lcd.setCursor(0,3);

    second == 0 ? lcd.print("Invalid") : total = (float)first / (float)second;

    lcd.print(total);
    lcd.setCursor(0,0);
    lcd.print("Hasil:");
    first = 0, second = 0;
    break;

  case 'C':
    first = 0;
    second = 0; 
    total = 0;
    lcd.clear();
    break;
  }
}

long SecondNumber()
{
  while( 1 )
  {
    char key = kpd.getKey();
    if(key >= '0' && key <= '9')
    {
      second = second * 10 + (key - '0');
      lcd.setCursor(0,2);
      lcd.print(second);
    }

    if(key == '=') break;  //return second;
  }
 return second; 
}
