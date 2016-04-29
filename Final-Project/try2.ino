#include <SoftwareSerial.h>
#include <stdlib.h>

//Sensor Jarak   
int echoPin = 2; // Echo Pin yang dekat ground
int trigPin = 3; // Trigger Pin
String apiKey = "7JJJ2SL0384EN9PB"; // Ubah dengan API Key ente bro!
SoftwareSerial ser(10, 11); // RX, TX
float duration, distance = 0;

void setup() {                 
  Serial.begin(9600);
  ser.begin(9600);
  ser.println("AT+RST");
  pinMode(trigPin, OUTPUT);
   pinMode(echoPin, INPUT);
}

void loop() {
 
  float val = 0;
      /* The following trigPin/echoPin cycle is used to determine the
 distance of the nearest object by bouncing soundwaves off of it. */ 
     digitalWrite(trigPin, LOW); 
     delayMicroseconds(2); 
    
     digitalWrite(trigPin, HIGH);
     delayMicroseconds(10); 
     
     digitalWrite(trigPin, LOW);
     duration = pulseIn(echoPin, HIGH);
     
     //Calculate the distance (in cm) based on the speed of sound.
     distance = duration/58.2;
     
      val += distance;
      delay(500);
  char buf[16];
  String strJar = dtostrf(val, 4, 1, buf);
  Serial.println(distance);
  Serial.println(val);
  Serial.println(strJar);
 
  String cmd = "AT+CIPSTART=\"TCP\",\"";
  cmd += "184.106.153.149"; // api.thingspeak.com
  cmd += "\",80";
  ser.println(cmd);
  
  if(ser.find("Error")){
    Serial.println("AT+CIPSTART error");
    return;
  }
 
  String getStr = "GET https://api.thingspeak.com/update?api_key=";
  getStr += apiKey;
  getStr +="&field1=";
  getStr += String(strJar);
  getStr += "\r\n\r\n";

  cmd = "AT+CIPSEND=";
  cmd += String(getStr.length());
  ser.println(cmd);
  ser.print(getStr);

  if(ser.find("")){
    ser.print(getStr);
  }
  else{
    ser.println("AT+CIPCLOSE");
    Serial.println("AT+CIPCLOSE");
  } 
    delay(16000); 
}
