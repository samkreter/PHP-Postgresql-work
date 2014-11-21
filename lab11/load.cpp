#include <iostream>
#include <sqlite3.h>
#include <fstream>
#include <string>

using namespace std;

int main(int argc, char** argv)
{
  // if(argc != 4)
  //   {
  //     std::cerr << "USAGE: " << argv[0] << " <database file> <table name> <CSV file>" << std::endl;
  //     return 1;
  //   }

  ifstream readFile("sam.csv");
  if(!readFile.is_open()){
    std::cout<<"file not able to be opened";
    return -1;
  }
  string line;

  while(readFile >> line){
    string delimiter = ",";

    size_t pos = 0;
    std::string token;
    while ((pos = line.find(delimiter)) != std::string::npos) {
        token = line.substr(0, pos);
        std::cout << token << std::endl;
        line.erase(0, pos + delimiter.length());
    }
    cout<<line;
    cout<<endl;
  }


  string hey;



  return 0;
}
