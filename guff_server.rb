require 'rubygems' # not necessary with ruby 1.9 but included for completeness
require 'sinatra'
require "sinatra/reloader" if development?
require 'data_mapper'
require 'json'

configure :development do
  #DataMapper.setup :default, "sqlite://#{Dir.pwd}/development.db"
  DataMapper.setup(:default, 'mysql://guff:guff@127.0.0.1/guff')
end

configure :production do
end

class Message
  include DataMapper::Resource
  
  property :id, Serial
  property :ip, String
  property :message, String
  property :accuracy, String
  property :latitude, String
  property :longitude, String
  property :created_at, DateTime
  property :updated_at, DateTime
end

DataMapper.finalize
DataMapper.auto_upgrade!

get '/messages/:latitude/:longitude' do
  expiry = Time.now - 7200
  @messages = repository(:default).adapter.select("SELECT ((acos( cos( radians(#{params[:latitude]}) ) * cos( radians( a.latitude ) ) * cos( radians( a.longitude ) - radians(#{params[:longitude]}) ) + sin( radians(#{params[:latitude]}) ) * sin( radians( a.latitude ) ) )) * 6371) as distance, a.* FROM messages a WHERE created_at > '#{expiry.strftime('%Y-%m-%d %H:%M:%S')}' HAVING distance < 0.2")
  @messages_hash = @messages.map { |row| Hash[row.members.zip(row.values)] }
  
  response['Access-Control-Allow-Origin'] = "*"
  content_type :json
  @messages_hash.to_json
end

post '/send' do
  
  @message = Message.create(
    :message      => params[:message],
    :accuracy       => params[:accuracy],
    :latitude       => params[:latitude],
    :longitude       => params[:longitude],
    
    :created_at => Time.now
  )
  if @message.save
    response['Access-Control-Allow-Origin'] = "*"
    content_type :json
    { :success_message => 'Message posted' }.to_json
  end
  
end